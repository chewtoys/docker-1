#!/bin/sh

function init() {
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    STATUS=$(vault status|grep -i "initialized"|awk '{ print $2}')

    # Initializing vault
    if [ $STATUS = "false" ]; then
        vault operator init > $KEYS_FILE
        echo "Vault initialized!"
    elif [ $STATUS = "true" ] && [ ! -s $KEYS_FILE ]; then
        echo -e "Vault is already initialized.\n"
        echo "Token: $ROOT_TOKEN"
        unseal
    else 
        echo -e "Vault is already initialized.\n"
        echo "Token: $ROOT_TOKEN"
        exit 0;
    fi

    unseal

}

function unseal() {

    # Unseling Vault
    KEYS_TOKEN=$(cat $KEYS_FILE | grep "Unseal" | awk '{print $4}' > $UNSEAL_KEYS)

    while read lines
    do 
        echo "Unsealing ... $lines"
        vault operator unseal $lines
    done < $UNSEAL_KEYS

    upgrade_kv
}

function upgrade_kv() {

    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null

    echo "Upgrading defaulf secret"
    vault kv enable-versioning secret/
    vault kv put secret/init pass=s3cr3t
    
    policies
}

function policies() {
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    echo "Creating policies ..."

        for policies in $(ls policies/ | awk -F'.' '{print $1}')
            do
                echo "Policy $policies created."
                vault policy write $policies policies/$policies.hcl
        done

    okta
}

function okta() {

    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null
    
    vault auth enable okta

    vault write auth/okta/config base_url="okta-emea.com" organization="sparknetworks" token="00Xape2-53TMT4z2siosZXhR5UL-yDSS_V9cPqYIdR"

    vault write auth/okta/groups/Okta-IT-Operations policies=devops

    database

}

function database() {

    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null

    vault secrets enable database

    vault write auth/okta/groups/Okta-Vault-DBA policies=database

    secrets

}

function secrets() {
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null
    
    # Activating SSH
    vault secrets enable ssh
    vault write ssh/roles/no_ssh_key key_type=otp default_user=ubuntu allowed_users=root,vogon,admin port=22 cidr_list=0.0.0.0/0
    vault write ssh/creds/no_ssh_key ip=0.0.0.0

    vault secrets enable -path=ssh-client ssh
    vault write -field=public_key ssh-client/config/ca generate_signing_key=true | tee trusted-user-ca-keys.pem

    users
}

function users() {

    echo "Userpass enabled."
    vault auth enable userpass

    echo "Creating user admin (for testing)"
    vault write auth/userpass/users/admin password=admin policies=devops

    postgres_policy
}

function postgres_policy() {

    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null


    vault write database/config/postgres \
    plugin_name=postgresql-database-plugin \
    allowed_roles="admin" \
    connection_url="postgresql://{{username}}:{{password}}@db_postgres:5432/postgres?sslmode=disable" \
    username="postgres" \
    password="example"

    vault write database/roles/admin \
    db_name=postgres \
    creation_statements="CREATE ROLE \"{{name}}\" WITH LOGIN PASSWORD '{{password}}' VALID UNTIL '{{expiration}}'; \
        GRANT SELECT ON ALL TABLES IN SCHEMA public TO \"{{name}}\";" \
    default_ttl="1h" \
    max_ttl="24h"

}


KEYS_FILE=keys.txt 2> /dev/null
UNSEAL_KEYS=ukeys.txt 2> /dev/null

$@