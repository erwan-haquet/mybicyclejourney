# Translation documentation

## Guideline

#### Message keys
Message keys are based on 2 (and optionnaly 3) levels :
- `category` : the root parameter, identify the global context. `Categories` are limited in number and their meanings are all listed below.
- `group` : *Optionnal*, depending on the `category`, give further context.
- `TBD` : the last parameter, it should describe the meaning of the message as much as possible. It MUST NOT be multi level.

##### Categories
- `general` : [2 level key], used for global translations.
- `pages` : [3 level key], used for static pages where `group` is the page name.
- `form` : [3 level key], (*label*, *placeholder*, *help*...), used for generic form translation. 

##### Group
`Group`s MUST respect their category rules.

#### Format
We are using `yaml` as translation file format.

## Usage
Extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=5 fr
```
