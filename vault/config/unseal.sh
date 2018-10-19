#!/bin/sh

function init() {
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')

    # Initializing vault
    if [ ! -s $KEYS_FILE ]; then
        vault operator init > $KEYS_FILE
        echo "Vault initialized!"
    elif [ $ROOT_TOKEN = "" ] && [ ! -s $KEYS_FILE ]; then
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

    audit
}

function audit() {
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null

    mkdir -p /var/logs/vault/

    vault audit enable file file_path=/var/logs/vault/audit.log

    okta
}

function okta() {
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null
    
    vault auth enable okta

    vault write auth/okta/config base_url="okta-emea.com" organization="Okta-IT-Operations" token="00Xape2-53TMT4z2siosZXhR5UL-yDSS_V9cPqYIdR"

    vault write auth/okta/groups/Okta-IT-Operations policies=Operations

    database

}

function database() {

    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null

    vault secrets enable database

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
}

# Keys file name

KEYS_FILE=keys.txt 2> /dev/null
UNSEAL_KEYS=ukeys.txt 2> /dev/null

$@