# Translation documentation

## Guideline

#### Message keys
Message key are based on 3 important levels, for example `pages.homepage.hero_title` will be decomposed in :
- `page`: the *category*, is the root parameter to identify the context of translation. *Categories* are limited in number and their meanings are all listed below.
- `homepage`: the *group*, encompass a collection of translations and bring further context.
- `hero_title`: the

| Message key                          | Description                                                                                       |
|--------------------------------------|---------------------------------------------------------------------------------------------------|
| label.foo                            | For form form labels.                                                                             |
| flash.foo                            | For flash messages.                                                                               |
| error.foo                            | For error messages.                                                                               |
| help.foo                             | For help text used with forms.                                                                    |
| foo.heading                          | For a heading.                                                                                    |
| foo.paragraph0                       | For the first paragraph after a heading.                                                          |
| foo.paragraph1                       | For the second paragraph after a heading.                                                         |
| foo.paragraph2 .html                 | A third paragraph where HTML is allowed inside the translation.                                   |
| foo                                  | For any common strings like “Show all”, “Next”, “Yes” etc.                                        |
| vendor.bundle.controller.action. foo | For any non-reusable translation.                                                                 |

#### Format
We are using `yaml` as translation file format.

## Usage
Extract new translations : 
```bash
# Example for French translations
$ php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=5 fr
```
