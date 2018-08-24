#!/bin/sh

# set -x

# Setup Consul ACLs on servers and clients

SERVERS="consul-stg.affinitas.io"
CLIENTS_CONSUL="consul-stg.affinitas.io"
CLIENTS_VAULT="vault-stg.affinitas.io"

function initial_token() {

    echo "Bootstrapping ACLs on a new cluster";

    curl -s -X PUT http://${SERVERS}/v1/acl/bootstrap -o "master_token"
    awk -F'"' '{ print $4 }' master_token
    
    if [ ! -z master_token ]; then
        echo "Restarting consul servers ..."
        awk -F'"' '{ print $4 }' master_token
    else
        echo "Error to generate token"
        exit 1;
    fi

    # sleep 5

    # create_agent_token
}

function create_agent_token() {
    MASTER_TOKEN=$(awk -F'"' '{ print $4 }' master_token)
    
    echo "Create an Agent Token"

    for i in {1..1}
        do

            echo "----> $i"
            curl -X PUT -H "X-Consul-Token: $MASTER_TOKEN" -d '{"Name": "Agent Token","Type": "client","Rules": "node \"\" { policy = \"write\" } service \"\" { policy = \"read\" }"}' http://$SERVERS/v1/acl/create -o "client_token"
            sleep 2;

    done;

    CLIENT_TOKEN=`awk -F'"' '{ print $4 }' client_token`

    echo "Agent Token created."
    # set_agent_token
}

# Grap the Agent Token ID

function set_agent_token() {
    
    MASTER_TOKEN=$(awk -F'"' '{ print $4 }' master_token)
    CLIENT_TOKEN=`awk -F'"' '{ print $4 }' client_token`
    
    echo "ACL agent token setting";

    curl -X PUT -H "X-Consul-Token: $MASTER_TOKEN" -d '{ "Token": "'$CLIENT_TOKEN'" }' http://$SERVERS/v1/agent/token/acl_agent_token  

    echo "Agent Token Set."
}

function enable_acl_clients() {

    MASTER_TOKEN=$(awk -F'"' '{ print $4 }' master_token)
    CLIENT_TOKEN=`awk -F'"' '{ print $4 }' client_token`

    echo "Enable ACLs on the Consul Clients";

    for i in {1..2}
    do
        curl -X PUT -H "X-Consul-Token: ${MASTER_TOKEN}" -d '{ "Token": "'${CLIENT_TOKEN}'" }' http://$CLIENTS_CONSUL/v1/agent/token/acl_agent_token
        sleep 2;
        curl -X PUT -H "X-Consul-Token: ${MASTER_TOKEN}" -d '{ "Token": "'${CLIENT_TOKEN}'" }' http://$CLIENTS_VAULT/v1/agent/token/acl_agent_token
        sleep 2;
    done

    echo "ACL Clients enabled."
}

function registrator() {

    echo "Restarting registrator ..."
    docker restart $(docker container ls | grep "consul_registrator" | awk '{ print $1 }') 
}

$@