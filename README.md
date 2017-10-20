# eSATeamSpeakBundle

This Bundle give you a connection to a TeamSpeak³-Server. It listen add events and triggered listener in your project.

## Installation

Run `composer require esports-academy/backup-bundle` to use eSATeamSpeakBundle in your Project.

## Configuration

Add to `AppKernel.php`
```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            // ...
            new eSA\TeamSpeakBundle\ESATeamSpeakBundle(),
            // ...
            
            return $bundles;
        }
        // ...
    }
```
    
config.yml
```yaml
    esa_team_speak:
        host: ts.es-a.org       // TeamSpeak-IP
        port: 9987              // TeamSpeak-Port
        query_port: 10011       // Serverquery-Port
        username: serverquery   // Serverquery-Username
        password: p4ssw0rd      // Serverquery-Password
        nickname: James         // Nickname
        timeout: 10             // Timeout in Seconds
```

## Usage

### Create your method
```php
    class TeamSpeakBot {
        public function onClientEnterView($event) {
            // do stuff
        }
    }
```

services.yml

```yaml
    services:
        AppBundle\TeamSpeakBot:
            tags:
                - { name: kernel.event_listener, event: teamspeak.client_enter_view, method: onClientEnterView }            
```

To run the bot execute `php bin/console teamspeak:bot:run` or `php bin/console teamspeak:bot:start` for background job.