
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 80,   host:  8080    # apache
  config.vm.network "forwarded_port", guest: 5432, host: 54320    # postgres
  config.vm.network "forwarded_port", guest: 3306, host: 33060    # mysql
  config.vm.network "forwarded_port", guest: 1080, host:  1080    # mailcatcher

end
