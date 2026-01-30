Recipe & Ingredient Search Platform (Drupal 10)
INTRODUCTION

This application is a Drupal 10–based Recipe & Ingredient Search Platform built on top of the Umami demo profile and extended with Search API, Facets, custom plugins, and custom Drush commands.

The purpose of this application is to demonstrate enterprise‑grade Drupal backend concepts such as:

Search indexing using Search API

Faceted search using the Facets module

Custom Search API processors and Views field plugins

Custom Drush CLI commands for statistics and maintenance

Clean configuration management and reproducible local setup using DDEV

This project can be used as:

A learning reference for advanced Drupal backend development

A starter template for content‑heavy, search‑driven applications

A technical showcase for interviews and architectural discussions

PURPOSE OF THE APPLICATION

The application focuses on recipes and ingredients, allowing users to:

Search recipes efficiently using indexed content

Filter search results using facets (tags, ingredients, categories, etc.)

View computed data such as Ingredient Count directly in Search API–based Views

Generate recipe statistics via custom Drush commands

It showcases how Drupal can be extended beyond standard content rendering into a powerful search and data platform.

KEY CONTRIBUTIONS & FEATURES
Search & Indexing

Search API configured using the Database backend

Custom Search API processors for additional indexed data

Reindexing and maintenance via Drush

Faceted Search

Facets module integrated with Search API

Facet Summary block used for active filters

Custom access control for facets

Custom Development

Custom Drush command for Recipe Statistics

Custom Views Field Plugin (Ingredient Count) used inside Search API Views

Proper cache metadata (contexts, tags, max-age)

Architecture

Configuration‑driven setup (config/sync + web/split)

DDEV‑based local environment

Composer‑managed dependencies

REQUIREMENTS

Docker

DDEV

Composer

PHP 8.1+

Drupal modules:

Search API

Facets

Views

Umami Demo Profile

LOCAL SETUP USING DDEV
1️⃣ Clone the repository
git clone <repository-url>
cd <project-directory>

2️⃣ Start DDEV
ddev start

3️⃣ Install Composer dependencies
ddev composer install


This installs:

Drupal core

Contributed modules (Search API, Facets, etc.)

Required PHP dependencies

INSTALL DRUPAL USING UMAMI PROFILE
4️⃣ Install Drupal with Umami
ddev drush site:install demo_umami \
  --account-name=admin \
  --account-pass=admin \
  --site-name="Recipe Search Platform" -y


Login:

Username: admin

Password: admin

CONFIGURATION IMPORT (STEP‑BY‑STEP)

All site configuration is stored in config/sync, with custom overrides in Config Split (web/split).

5️⃣ Enable the Config Split
ddev drush cset config_split.config_split.umami_configurations status true -y


umami_configurations is the machine name of the split containing custom recipe-related configs (node types, taxonomy, blocks, views, etc.)

This tells Drupal to include configs in the web/split folder during import

6️⃣ Import configuration
ddev drush cim -y


This will import:

Search API indexes

Views (including Search API Views)

Facets & Facet Summary blocks

Custom permissions and settings

7️⃣ Rebuild cache
ddev drush cr

SEARCH INDEXING SETUP
8️⃣ Verify Search API index
ddev drush search-api:list

9️⃣ Index content
ddev drush search-api:index


This indexes:

Recipes

Ingredients

Tags and referenced entities

FACET IMPLEMENTATION

Facets are attached to the Search API View

Facet Summary block is placed in the layout

Only the Facet Summary block is required in the UI

Active filters are automatically reflected

CUSTOM DRUSH COMMAND: RECIPE STATISTICS

A custom Drush command provides recipe‑level insights such as:

Total number of recipes

Average ingredient count

Top ingredients used

Usage
ddev drush recipe:stats


This command demonstrates:

Dependency Injection in Drush commands

Entity queries

Output formatting

CUSTOM VIEWS FIELD PLUGIN (SEARCH API VIEW)
Ingredient Count Field

Implemented as a Views Field Plugin compatible with Search API

Displays the number of ingredients per recipe

Appears under the Search API datasource fields in Views UI

This demonstrates:

Difference between Content Views and Search API Views

Proper plugin annotation and discovery

Computed fields in search‑driven views

CACHE & PERFORMANCE

Cache contexts added where required

Cache tags used for entity-based invalidation

Max‑age configured (~1 week) for expensive computations

USER NOTES FOR CLONING

When a new user clones this repository:

Clone and cd into the project folder

Start DDEV: ddev start

Install dependencies: ddev composer install

Install Drupal using Umami demo profile:

ddev drush site:install demo_umami \
  --account-name=admin \
  --account-pass=admin \
  --site-name="Recipe Search Platform" -y


Enable the Config Split:

ddev drush cset config_split.config_split.umami_configurations status true -y


Import configuration:

ddev drush cim -y


Rebuild cache:

ddev drush cr


✅ No UUID changes required – the config split ensures that only your custom configs (web/split) are imported, avoiding conflicts with the Umami demo profile.

MAINTAINERS

Current maintainer for Drupal 10:

Anwesha Sinha – https://www.drupal.org/u/anweshasinha91

FINAL NOTES

This project intentionally focuses on backend correctness, extensibility, and real-world Drupal patterns rather than UI polish.

It is ideal for:

Advanced Drupal learners

Backend interview preparation

Search-driven Drupal applications

Happy building 🚀
