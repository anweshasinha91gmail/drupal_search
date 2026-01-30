# 🍽 Recipe & Ingredient Search Platform (Drupal 10)

---

## **Introduction**

This application is a **Drupal 10–based Recipe & Ingredient Search Platform** built on top of the **Umami demo profile**, extended with **Search API, Facets, custom plugins, and custom Drush commands**.

It demonstrates **enterprise-grade Drupal backend concepts** such as:

- **Search indexing** using Search API
- **Faceted search** using the Facets module
- **Custom Search API processors** and Views field plugins
- **Custom Drush CLI commands** for statistics and maintenance
- **Clean configuration management** and reproducible local setup using DDEV

**Use cases:**

- Learning reference for advanced Drupal backend development
- Starter template for content-heavy, search-driven applications
- Technical showcase for interviews and architectural discussions

---

## **Purpose of the Application**

The platform focuses on **recipes and ingredients**, allowing users to:

- Search recipes efficiently using indexed content
- Filter search results using facets (tags, ingredients, categories, etc.)
- View computed data such as **Ingredient Count** directly in Search API Views
- Generate recipe statistics via custom Drush commands

It showcases how Drupal can be extended **beyond standard content rendering** into a powerful **search and data platform**.

---

## **Key Contributions & Features**

### **Search & Indexing**
- Search API configured using the **Database backend**
- Custom Search API processors for additional indexed data
- Reindexing and maintenance via Drush

### **Faceted Search**
- Facets module integrated with Search API
- Facet Summary block used for active filters
- Custom access control for facets

### **Custom Development**
- **Custom Drush command** for Recipe Statistics
- **Custom Views Field Plugin** (`Ingredient Count`) for Search API Views
- Proper cache metadata (contexts, tags, max-age)

### **Architecture**
- Configuration-driven setup (`config/sync` + `web/split`)
- DDEV-based local environment
- Composer-managed dependencies

---

## **Requirements**

- Docker
- DDEV
- Composer
- PHP 8.1+

**Drupal modules:**

- Search API
- Facets
- Views
- Umami Demo Profile

---

## **Local Setup Using DDEV**

### 1️⃣ Clone the repository


git clone <repository-url>
cd <project-directory>
ddev start
ddev composer install

ddev drush site:install demo_umami \
  --account-name=admin \
  --account-pass=admin \
  --site-name="Recipe Search Platform" -y

ddev drush cset config_split.config_split.umami_configurations status true -y

ddev drush config:import \
  --source=/var/www/html/web/splits \
  --partial -y


ddev drush cr

----
## **No UUID changes required** – the Config Split ensures only your custom configs (web/split) are imported, avoiding conflicts with the Umami demo profile.

## **Maintainers**

Current maintainer for Drupal 10:

Anwesha Sinha – https://www.drupal.org/u/anweshasinha91
