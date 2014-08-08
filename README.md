# PKJ Any Parent Type, Wordpress Plugin

This plugin lets you select what parent pages you allow to set for custom post types. By default only the same type is allowed.

![Alt text](/screenshot-1.png?raw=true "")


The PKJ Any Parent Type plugin lets you customize what parent post types that are allowed for each custom post type.
This makes it possible to have one-to-many relationship between custom post types and not just itself.

Lets say you have two custom post-types:

- Person
- Activiy

The *Person* CPT contains, well, a person. Each person can have many *Activity*. This is not possible using vanilla wordpress without many hacks, this plugins helps  you do this easily! Just configure it in the plugins options page that "The Activity type can have Parent as Person", and the "Person can have parent as "Page".

Now we create a post of type *Page* named "Persons".

We create a post type of "Person" titled "Peter" and set the parent page to "Persons".

We create a post type of "Activity" named "Ran two miles" and set the parent person to "Peter".

Now you have great urls:

- http://youtsite.com/persons <- Page
- http://youtsite.com/persons/peter <- Person
- http://youtsite.com/persons/peter/ran-two-miles <- Activity


## Creating custom post types.

There are just one thing to remember, set "hierarchical" to true when creating new post  types. Do not include the "rewrite" option.

