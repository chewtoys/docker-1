# Prometheus

## Getting Started

Prometheus is an open-source systems monitoring and alerting toolkit

### Prerequisites

```
Last version of docker in a swarm mode to using that stack.
```

### Running
```
docker stack deploy -c prometheus.yml prometheus
```

### Checking
```
docker service ls
```
or
```
docker stack ls
```

Architecture
__________
<img src="./architecture.svg">
__________

### Authors

Rodrigo Carvalho </br>
DevOps Engineering </br>
Skype: rdgacarvalho

