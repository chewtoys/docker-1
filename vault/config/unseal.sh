#!/bin/sh

# Keys file name
KEYS_FILE=keys.txt
UNSEAL_KEYS=ukeys.txt

# Initializing vault
vault operator init > $KEYS_FILE

if [ $? -eq 0 ]; then
    echo "Vault initialized!"
else
    echo "Vault initialized already. Wait..."
fi

# Unseling Vault
KEYS_TOKEN=$(cat $KEYS_FILE | grep "Unseal" | awk '{print $4}' > $UNSEAL_KEYS)
UNSEAL_KEYS=ukeys.txt

while read lines
 do 
    vault operator unseal $lines
done < $UNSEAL_KEYS

# List vault status
vault status