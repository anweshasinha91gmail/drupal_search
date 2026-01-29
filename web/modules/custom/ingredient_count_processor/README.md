## INTRODUCTION

The Ingredient Count Processor module is a specialized Drupal extension designed to bridge the gap between complex entity data and Search API-driven displays. It provides a highly efficient way to compute, index, and render the total count of multi-value ingredient fields within recipe search interfaces.

The primary use case for this module is:

Computed Indexing: Automatically calculating the number of ingredients during the Search API indexing process to allow for fast sorting and filtering by recipe complexity.

Dynamic Search Views: Providing a custom Views field plugin specifically for Search API indexes to display real-time ingredient counts without extra database queries.

Enhanced UX: Enabling a responsive, Bootstrap-aligned search interface where the ingredient count is presented as a first-class data point alongside recipe metadata.

## REQUIREMENTS

This module requires the following:

Search API (core logic for indexing and data retrieval)

Views (for the administrative and front-end search displays)

A Recipe content type with a multi-value field named field_ingredients.

## INSTALLATION

Install as you would normally install a contributed Drupal module. See: https://www.drupal.org/node/895232 for further information.

## CONFIGURATION
Enable the Processor: Navigate to your Search API Index settings, go to the Processors tab, and enable the "Ingredient count" processor.

Map the Field: In the Fields tab of your Search API Index, add the "Ingredient count" property, set its type to Integer, and run a full re-index.

Add to View: In your Advanced Search View, add the field "Ingredient Count (Custom Plugin)" to your table or list display.

Layout Adjustments: Ensure your theme supports Bootstrap if you wish to utilize the responsive grid classes (col-md-2, etc.) applied to the exposed filters.

## MAINTAINERS

Current maintainers for Drupal 10:

- Anwesha Sinha - https://www.drupal.org/u/anweshasinha

