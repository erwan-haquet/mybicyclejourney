# Translation documentation

## Guideline
We are using a 3 levels [keyword messages](https://symfony.com/doc/current/translation.html#using-real-or-keyword-messages) architecture to uniquely identify our translations.
Translations are write in yaml, using [`icu format`](https://unicode-org.github.io/icu/userguide/format_parse/messages/) with one unique version per langage and the given file naming structure `messages+intl-icu.{locale}.yaml`.

### Message keys
- `context` : identify the global context. must remain limited in number and be descriptives in their meanings. they are all listed below.
  - `general` : [2 levels], used for global translations. eg: `general.ok`, `general.hello`.
  - `pages` : [3 levels], used for static pages where `group` is the page name. eg: `pages.homepage.welcome_message`.
  - `form` : [3 levels], (*label*, *placeholder*, *help*...), used for generic form translation. eg: `form.label.first_name`, `form.help.first_name`.
- `group` : (*optionnal*) they are tightly coupled to the `context` and should help to regroup translations.
- `TBD` : the last parameter, it should describe the meaning of the message as much as possible. It MUST NOT be multi level.

## Usage
Extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=3 fr
```
