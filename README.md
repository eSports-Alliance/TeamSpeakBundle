# eSATeamSpeakBundle

This Bundle give you a connection to a TeamSpeak³-Server. It listen add events and triggered listener in your project.

## Installation

Run `composer require esports-academy/backup-bundle` to use eSATeamSpeakBundle in your Project.

## Configuration

Add to `AppKernel.php`

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
    
config.yml

    esa_team_speak:
        host: ts.es-a.org       // TeamSpeak-IP
        port: 9987              // TeamSpeak-Port
        query_port: 10011       // Serverquery-Port
        username: serverquery   // Serverquery-Username
        password: p4ssw0rd      // Serverquery-Password
        nickname: James         // Nickname
        timeout: 10             // Timeout in Seconds

## Usage

Coming soon ...