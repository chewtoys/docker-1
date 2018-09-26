#!/bin/sh

# Keys file name
KEYS_FILE=keys.txt
UNSEAL_KEYS=ukeys.txt


function init() {

    # Initializing vault
    vault operator init > $KEYS_FILE

    if [ $? -eq 0 ]; then
        echo "Vault initialized!"
    else
        echo "Vault initialized already. Wait..."
    fi

    unseal

}

function unseal() {
    # Unseling Vault
    KEYS_TOKEN=$(cat $KEYS_FILE | grep "Unseal" | awk '{print $4}' > $UNSEAL_KEYS)
    UNSEAL_KEYS=ukeys.txt

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
    
    vault login $ROOT_TOKEN > /dev/null
    
    # Activating SSH/Okta
    vault secrets enable ssh
    vault auth enable okta
}

$@