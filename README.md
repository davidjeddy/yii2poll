[!WARNING]
**⚠️ This project has been archived and is no longer maintained. ⚠️**

Github has shown it does not respect its users. Other have said it better than I can.

- https://www.theregister.com/2022/06/30/software_freedom_conservancy_quits_github/
- https://www.andrlik.org/dispatches/migrating-from-github-motivation/
- https://techresolve.blog/2025/12/27/looking-to-migrate-company-off-github-whats-the/
- https://lord.io/leaving-github/
- https://dev.to/alanwest/how-to-actually-migrate-from-github-to-codeberg-without-losing-your-mind-33bf>
> Development has moved to Codeberg:
> **➡️ https://codeberg.org/DavidJEddy/yii2poll**
>
> Please update your remotes:
> ```bash
> git remote set-url origin https://codeberg.org/DavidJEddy/yii2poll
> ```

---
NOTICE: No longer maintained. Superseded by  https://github.com/davidjeddy/yii2-poll

yii2-poll
=========

Poll widget for Yii 2.x allows you to create basic custom polls for authenticated users to vote on.

Installing 
==========

- Run composer `require davidjeddy/yii2poll` on the terminal in your {project root}, OR add `"davidjeddy/davidjeddyyii2poll": "~2"` to your projects composer.json in the "required": [...] section then run `composer update`.
- Enbable the module in your apps config/web.config module list

Usage 
=====

Basic:
```PHP
    echo \davidjeddt\yii2poll\Poll::widget([
        'pollName'      => 'Do you like PHP?',
        'answerOptions' => ['Yes', 'No'],
    ]); 
```


Advanced:
```PHP
    echo \davidjeddt\yii2poll\Poll::widget([
        'pollName'      => 'Do you like PHP?',
        'answerOptions' => ['Yes', 'No'],
        'params'        => [
            'backgroundLinesColor' => '#DCDCDC',// html hex 
            'linesColor'           => '#DC0079' // html hex 
            'linesHeight'          => 20,       // in pixels
            'maxLineWidth'         => 200,      // in pixels
        ]
    ]); 
```