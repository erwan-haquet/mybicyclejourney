# Translation guideline 

## Documentation 
Translation can be really time-consuming if no rules are given, therefore this guideline will
help you to know how to structure and organize the way you are dealing with translations in the project. 

### General purpose 
- Translations are written in yaml, using the `.yaml` file extension
- Translations are formatted in [`ICU`](https://unicode-org.github.io/icu/userguide/format_parse/messages/) 
- Each translation is identified by a unique message key (see below)
- Each locale have its own file
- Every translation for a given locale is written in one `messages+intl-icu.{locale}.yaml` file.

#### Domains
The first level is called `domain`. It is used to split UI concerns :
- `web` : for the [web application](https://wwww.mybicycleproject.com).
- `email` : for email communications.

Domains are represented by namespaces directly in the root translation directory : `templates/{domain}/{translation_files}`.

#### Message key
We are using a 3 levels [keyword messages](https://symfony.com/doc/current/translation.html#using-real-or-keyword-messages) structure `level1.level2.level3`.
To guarantee a good maintainability and meaningful keys, they must respect the following 3 level `category.group.description` structure : 
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
