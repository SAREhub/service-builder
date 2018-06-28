# Service Builder
SAREhub Service Builder is a composer plugin which allows to inject recipes to projects.

## Status
This plugin is still under development process.

## Installation
Install plugin in global environment by using command described below.

```
composer global require sarehub/service-builder
```

## How to use it?
Use **inject** command inside terminal.

### Example usage:

``` 
    composer inject github SAREhub/service-builder-recipe Project/Namespace
```

This command should extract source files to _src/Project/Namespace_ directory in your working dir.

Additional files from recipe will be extracted in directories where have been placed before. In this case 
this will be _bin/init.sh_ folder in your working dir.

## Creating own recipe
At this moment Service Builder handle only github repositories. To make new recipe you should 
create repository on github.

After creating repository with files which are needed to be inside recipe you should add
*Recipe Entrypoint*.

### Recipe Entrypoint
Recipe Entrypoint is a configuration file which allows you to add additional files to
 recipe. Main files are stored inside **src** directory. Entrypoint has to be named 
 **recipe.json**.
 
Recipe Entrypoint structure:
```json
{
  "additionalFiles": [
    "path/to/additional/file.extension"
  ]
}
```

### Example recipe
<a href="https://github.com/SAREhub/service-builder-recipe">Click here to redirect to example Service Builder recipe.</a>