# Consul

## Getting Started

Consul is a distributed service mesh to connect, secure, and configure services across any runtime platform and public or private cloud

### Prerequisites

```
Last version of docker in a swarm mode
You can find an ansible playbook to setup a docker swarm cluster from scratch into ansible repository
```

### Running
```
docker stack deploy -c consul.yml consul
```

### Checking
```
docker service ls
```
or
```
docker stack ls
```

### Web UI
You can access the web interface to see your consul cluster and services as well. All new docker containers will be discovery by consul once you use add the environments below
```
environments:
    SERVICE_NAME: <your_service_here>
    SERVICE_TAGS: <your_tags_here>
```
Accessing the WebUI
```
http://<ip_of_your_docker_node>:8500
```

### Securities
I am working on security part such as ACLs, Intentions and so on

### Authors
Rodrigo Carvalho
DevOps Engineering
Skype: rdgacarvalho