# DSS ReadSpeaker Block, Drupal 8/9+ Version
Adds a ReadSpeaker 'Listen' button as a customisable block.

## Dependencies
* Block

## Install Module to Drupal 8/9 Project
In your composer file add this to the repositories array:


```
{
    "type": "vcs",
    "url": "git@github.com:DSSGOVAUS/dss_readspeaker_d.git"
}
```

Finally you just need to add the package to your composer require array:

```
"require": { 
    "dssgovau/dss_readspeaker": "^1.0" 
}
```

### Note

If this is your first time composer will ask you to generate a token, it will provide a link to do so in the terminal and after this has been made it will store for you so this should only need to be done once.
