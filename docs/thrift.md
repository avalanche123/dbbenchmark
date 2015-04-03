Thrift PHP Extension installation for Cassandra

_"The Apache Thrift software framework, for scalable cross-language services development, combines a software stack with a code generation engine to build services that work efficiently and seamlessly between C++, Java, Python, PHP, Ruby, Erlang, Perl, Haskell, C#, Cocoa, JavaScript, Node.js, Smalltalk, OCaml and Delphi and other languages."_

You need to install thrift and thrift_protocol extension. First, you have to install these packages:
```bash
sudo apt-get install git build-essential cmake pkg-config libboost-dev libboost-test-dev libboost-program-options-dev libevent-dev automake libtool flex bison pkg-config libssl-dev libsoup2.4-dev libboost-system-dev libboost-filesystem-dev libogg-dev libtheora-dev libasound2-dev libvorbis-dev libpango1.0-dev libvisual-0.4-dev libffi-dev libgmp-dev

```
## Java Server JRE

If it's not dine yet, install java.

## Download and install Thrift

```
sudo su - www-data
cd /home/www
git clone https://git-wip-us.apache.org/repos/asf/thrift.git thrift
cd thrift
git checkout 0.9.1
./bootstrap.sh
./configure
make
sudo make install
thrift --help
```

## Install thrift_protocol (php extension)

```
cd ..
wget https://raw.githubusercontent.com/apache/cassandra/cassandra-2.0.12/interface/cassandra.thrift
./thrift/compiler/cpp/thrift --gen php cassandra.thrift
sudo mkdir -p /usr/share/php/Thrift
sudo cp -R gen-php/ /usr/share/php/Thrift/packages/
sudo cp -R thrift/lib/php/src/* /usr/share/php/Thrift/
cd /usr/share/php/Thrift/ext/thrift_protocol
sudo su
phpize
./configure --enable-thrift_protocol
make
```

Then, write an ini file for thrift and add it to your php extensions:
```
echo "extension=/usr/share/php/Thrift/ext/thrift_protocol/modules/thrift_protocol.so" | sudo tee -a /etc/php5/mods-available/thrift_protocol.ini
php5enmod thrift_protocol
service php5-fpm restart
```