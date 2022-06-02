# Translation documentation

## Guideline
We are using a 3 levels [keyword messages](https://symfony.com/doc/current/translation.html#using-real-or-keyword-messages) structure.   
Translations are write in yaml, using [`icu format`](https://unicode-org.github.io/icu/userguide/format_parse/messages/) with one unique *message* file per locale.      
Each translated locale have is own file `messages+intl-icu.{locale}.yaml`.    
To split concerns, we are using top level `domain`s directories that refers to user interfaces.

### Domains
Each domain has it own namespace at root level : `templates/{domain}/*` :
- `web` : for web application. https://wwww.mybicycleproject.com.
- `email` : to translate email templates.

### Message keys
To guarantee a good maintenability and meanfull keys, they must respect the structure `context.group.name`: 
- `context` : identify the global context. must remain limited in number and be descriptives in their meanings. list below :
  - `general` : [2 levels], used for global translations. eg: `general.ok`, `general.hello`.
  - `pages` : [3 levels], used for static pages where `group` is the page name. eg: `pages.homepage.welcome_message`.
  - `form` : [3 levels], (*label*, *placeholder*, *help*...), used for generic form translation. eg: `form.label.first_name`, `form.help.first_name`.
- `group` : (*optionnal*) they are tightly coupled to the `context` and should help to regroup translations.
- `name` : the last parameter, it should describe the meaning of the message as much as possible. It MUST NOT be multi level.

## Usage
To extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=3 fr
```
