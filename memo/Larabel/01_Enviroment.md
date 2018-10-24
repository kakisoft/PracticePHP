## ララベル環境構築
公式の VagrantBoxを使用。  
<https://app.vagrantup.com/laravel/boxes/homestead>
```
vagrant box add laravel/homestead


config.vm.network "forwarded_port", guest: 80, host: 8080
config.vm.network "forwarded_port", guest: 3306, host: 4306
config.vm.synced_folder "./shared", "/vagrant/shared", type: "virtualbox", owner: 'apache',  mount_options: ['fmode=777', 'dmode=777']

```