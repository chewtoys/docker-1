# Atlantis

## Getting Started

Atlantis is Terraform Pull Request Automation tool. With atlantis you can track your terraform modules in Github, Gitlab or Bitbucket.

### Prerequisites

```
Last version of docker installed.
```

### Running
```
docker stack deploy -c atlantis.yml atlantis
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
You can access the web interface to see your atlantis cluster and services as well. All the new PR(s) can be see there.

___
Accessing the WebUI
```
http://<ip_of_your_docker_node>:4141
```
___

### Web UI

* Remember I am using traefik load balancer so, you need edit your hosts file and add consul.ellesmera.com there pointing to localhost.

1. Accessing UI

```
http://atlantis.ellesmera.com
```

### Authors

Rodrigo Carvalho </br>
DevOps Engineering </br>
Skype: rdgacarvalho
