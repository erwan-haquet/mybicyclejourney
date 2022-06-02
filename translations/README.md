# Translation documentation

## Guideline
### General purpose
Each domain have it own namespace at root level : `templates/{domain}/*`.   
Translations are write in yaml, using [`icu format`](https://unicode-org.github.io/icu/userguide/format_parse/messages/) with one unique file per locale `messages+intl-icu.{locale}.yaml`.     
We are using a 3 levels [keyword messages](https://symfony.com/doc/current/translation.html#using-real-or-keyword-messages) structure `level1.level2.level3`.  

### Domains
Domains are used to split concerns, they refers to user interfaces : 
- `web` : for the [web application](https://wwww.mybicycleproject.com).
- `email` : for email communications.

### Message keys
To guarantee a good maintenability and meanfull keys, they must respect the following 3 level `category.group.description` structure : 
- `category` : identify the global context, must remain limited in number and be descriptives in their meanings :
  - **general** : [2 level], used for global translations. eg: `general.ok`, `general.hello`.
  - **pages** : [3 levels], used for static pages where `group` is the page name. eg: `pages.homepage.welcome_message`.
  - **form** : [3 levels], (*label*, *placeholder*, *help*...), used for generic form translation. eg: `form.label.first_name`, `form.help.first_name`.
- `group` : (*optionnal*) is tightly coupled to the `context` and should help to regroup translations.
- `description` : the last parameter key, it should describe the meaning of the message as much as possible. It MUST NOT be multi level.

## Usage
To extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=3 fr
```
