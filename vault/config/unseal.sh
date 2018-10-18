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

    secrets
}

function secrets(){
    
    ROOT_TOKEN=$(cat $KEYS_FILE | grep "Token" | awk '{print $4}')
    # Root token
    echo "Root Token:: $ROOT_TOKEN"

    # Login into Vault 
    vault login $ROOT_TOKEN > /dev/null
    
    # Activating SSH
    vault secrets enable ssh
    vault write ssh/roles/no_ssh_key key_type=otp default_user=vagrant allowed_users=root,admin port=22 cidr_list=0.0.0.0/0
    vault write ssh/creds/no_ssh_key ip=0.0.0.0

    vault secrets enable -path=ssh-client ssh
    vault write -field=public_key ssh-client/config/ca generate_signing_key=true | tee trusted-user-ca-keys.pem
}

# Keys file name

KEYS_FILE=keys.txt
UNSEAL_KEYS=ukeys.txt

$@