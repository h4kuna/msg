# Resolved!

## php sysvmsg extension

## installation
```
git clone git@github.com:h4kuna/msg.git
cd msg
```

### How simulate error with code 43
> This behavior is expected.

Open two terminals.
- in first run `php remove.php 9`
- in second run `php remove.php 9`
In first terminal, you will see like this
```
PHP Fatal error:  Uncaught ReceiveException: msg_receive failed with error code "43". in /data/share/www/msg/src/common.php:72
Stack trace:
#0 /data/share/www/msg/remove.php(6): receive()
#1 {main}
  thrown in /data/share/www/msg/src/common.php on line 72
```

### How execute by supervisor
Install supervisor by `sudo apt install supervisor` copy [config file](src/msg.conf) `sudo cp src/msg.conf /etc/supervisor/conf.d/`. Edit uppercase to real value `sudo nano /etc/supervisor/conf.d/msg.conf`.
End reload supervisor `sudo supervisorctl reread && sudo supervisorctl reload`. And check if all is running `sudo supervisorctl status`. You must see
```
msg RUNNING pid 1080, uptime 6:17:59
```
Wait a few hours for the file `received.log` to create. In content you will see anything like this
```
[2020-09-02T14:14:27+0200] pid[1080] msg_receive failed with error code "43".
[2020-09-03T11:25:37+0200] pid[1080] msg_receive failed with error code "43".
[2020-09-03T22:51:37+0200] pid[1080] msg_receive failed with error code "43".
```
