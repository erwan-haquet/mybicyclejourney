# Translation documentation

## Guideline

### Message keys
Translations used message keys as unique identifier. They are based on 2 (or optionnaly 3) levels :
- `category` : identify the global context, `categories` are limited in number and their meanings are all listed below.
- `group` : *Optionnal*, depending on the `category`, it give further context.
- `TBD` : the last parameter, it should describe the meaning of the message as much as possible. It MUST NOT be multi level.

#### Categories
- `general` : [2 level key], used for global translations.
- `pages` : [3 level key], used for static pages where `group` is the page name.
- `form` : [3 level key], (*label*, *placeholder*, *help*...), used for generic form translation. 

### Format
We are using `yaml` as translation file format.

## Usage
Extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=5 fr
```
