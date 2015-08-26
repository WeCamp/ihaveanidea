# vagrant init ubuntu/trusty64

Vagrant.configure("2") do |config|
    config.vm.box = "trusty64"
    config.vm.box_url = "http://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-amd64-vagrant-disk1.box"

    config.vm.network :private_network, ip: "192.168.192.168"

    config.vm.provider :virtualbox do |v|
        v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
        v.customize ["modifyvm", :id, "--memory", 1024]
        v.customize ["modifyvm", :id, "--name", "speakeracademy"]
    end

    config.vm.provision "ansible" do |ansible|
        ansible.playbook = "ansible/provision.yml"
        ansible.extra_vars = {
            hostname: "speakeracademy",
            dbuser: "speakeracademy",
            dbpasswd: "speakeracademy",
            databases: ["development"],
            sites: [
                {
                    hostname: "speakeracademy.192.168.192.168.xip.io",
                    document_root: "/vagrant/web"
                }
            ],
            php_configs: [
                { option: "upload_max_filesize", value: "100M" },
                { option: "post_max_size", value: "100M" }
            ],
            enable_swap: "yes",
            install_gems: ["compass", "zurb-foundation"],
            install_db: "yes",
            install_ohmyzsh: "yes",
            install_node: "yes",
            install_web: "yes",
            install_mailcatcher: "yes",
            install_hhvm: "yes",
            install_javascript_build_system: "yes"
        }
    end
end