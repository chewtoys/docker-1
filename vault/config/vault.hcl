ui = true

listener "tcp" {
  address         = "vault_server:8200"
  cluster_address = "vault_server:8201"
  tls_disable     = "true"
}

storage "consul" {
  address       = "consul_server:8500"
  path          = "vault/"
  scheme        = "http"
  service       = "vault"
  check_timeout = "60s"
}

# HA settings
cluster_addr = "http://vault_server:8201"
api_addr = "http://vault_server:8200"
