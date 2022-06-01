# Translation documentation

## Guideline

#### Message keys
| Message key                          | Description                                                                                       |
|--------------------------------------|---------------------------------------------------------------------------------------------------|
| label. foo                           | For form form labels.                                                                             |
| flash. foo                           | For flash messages.                                                                               |
| error. foo                           | For error messages.                                                                               |
| help. foo                            | For help text used with forms.                                                                    |
| foo .heading                         | For a heading.                                                                                    |
| foo .paragraph0                      | For the first paragraph after a heading.                                                          |
| foo .paragraph1                      | For the second paragraph after a heading.                                                         |
| foo.paragraph2 .html                 | A third paragraph where HTML is allowed inside the translation.                                   |
| _foo                                 | Starting with underscore means the the translated string should start with a lowercase character. |
| foo                                  | For any common strings like “Show all”, “Next”, “Yes” etc.                                        |
| vendor.bundle.controller.action. foo | For any non-reusable translation.                                                                 |

#### Format
We are using XLIFF format.


## Usage
To generate your translation files : 
```bash
$ php bin/console translation:extract --force --sort=asc --as-tree {language}
```

