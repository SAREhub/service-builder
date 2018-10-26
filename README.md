# Service Builder
SAREhub Service Builder is a composer plugin which allows to inject recipes to projects.

## Status
This plugin is still under development process.

## Installation
Install plugin globally by using:

```
composer global require sarehub/service-builder
```

## Commands:

### inject
Injecting recipe to project

Usage:

For Github repository:
```
    composer inject github:<account>/<repository>
```

For Http or Https repository:
```
    composer inject <http|https>:domain.com/recipe.json
```

## Creating own recipe

### Recipe manifest
Recipe manifest is a configuration file
which allows you to execute some tasks like copy template files.
Recipe manifest file my be named **recipe.json**.

Structure:
```json
{
    "name": "<recipe_name>",
    "archiveUri": "<uriToRecipeArchive>",
    "injectTasks": [
        {
            "type": "<task_type>",
            "parameters": {
                "task_param": ""
            }
        }
    ]
}
```

#### Supported Inject task types:

**CopyFiles** - copies selected files/directories from recipe archive
    to selected paths in project directory.

Parameters:
   - files - json object with files to copy

Example
```json
{
    "type": "CopyFiles",
    "parameters": {
        "files" : {
         "file.txt": "bin/file.txt",
         "src": "",
         "some_files/": ""
        }
    }
}
```
