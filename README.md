
---

# Sustainable Planet: Building Healthier Cities Together

## Demonstrative Working Prototype in Website:

http://www.clouddrone.top/

## Documentation:

The web application integrates **multi-source urban datasets** (satellite imagery, IoT sensors, waste statistics, and flood forecasts) into a unified GIS platform for sustainable city planning. Planners can upload, analyze, and visualize data in real-time to support climate-resilient urban development.

---

## Feature

**Sustainable Planet** is a decision-making platform for urban planners to track waste, pollution, and climate resilience data. It integrates **smart drones, IoT-enabled smart bins, and plastic collector vending machines** with **real-time dashboards** and **educational modules for citizens and kids**.

---

## Technology Stack

The platform is built using a modern full-stack architecture:

* **Frontend:** HTML, CSS, JS for responsive UI.
* **Backend:** PHP, Node.js with Express.js for RESTful APIs.
* **Database:** MySQL for structured and unstructured data.
* **Cloud Hosting:** —
* **Data Integration:** NASA Earth Observation APIs, IoT device data streams.

---

## API Configuration

We fetch **real-time environmental data** using **NASA Open API (EONET)**. This provides access to **event-based Earth observation data** (floods, wildfires, storms, etc.), which is integrated into the system to generate **climate-resilience maps and alerts**. The configuration includes **API key authentication, rate-limit handling, and scheduled cron jobs** for automated data refresh.

---

**NASA Data Source :**
1.	https://www.earthdata.nasa.gov/centers/sedac-daac
2.	https://www.earthdata.nasa.gov/learn/data-in-action/  forest-expansion-drought-impact-woodland-mapping
3.	https://www.earthdata.nasa.gov/data/catalog/ghrc-daac-gpmtfmifld-1
4.	API  : https://eonet.gsfc.nasa.gov/docs/v2.1
5.	https://earth.gsfc.nasa.gov/hydro/data/nasa-usda-global-soil-moisture-data
6.	https://developers.google.com/earth-engine/datasets/catalog/GLOBAL_FLOOD_DB_MODIS_EVENTS_V1
7.	https://developers.google.com/earth-engine/datasets/catalog/projects_landandcarbon_assets_
8.	https://developers.google.com/earth-engine/datasets/tags/soil-moisture 

---
## Usage

* **Urban Planners** → Get dashboards for waste collection, flood zones, population growth, forest loss, and soil moisture.
* **Citizens** → Learn about city health, waste habits, and plastic impact.
* **Kids** → Play interactive games, watch NASA videos, and join eco-tasks.
* **Policymakers** → Access data-driven reports for sustainable urban development.

---

## Responsive Design

The web app uses **mobile-first responsive layouts**, ensuring smooth access across **desktops, tablets, and smartphones**. Key charts and maps **auto-adjust for any screen size**.

---

## Design System

A **clean, accessible design system** powered by **Material Design + Bootstrap**. Components (**cards, modals, dashboards, charts**) follow **WCAG accessibility guidelines** for inclusivity.

---

## Project Structure

The repository follows a **modular design**:

* **/frontend** → UI code (HTML, CSS, JS)
* **/backend** → API services (Node/Express)
* **/database** → MySQL
* **/tests** → Unit & integration test cases
* **/docs** → Project documentation and guides

---

## Testing

* **Unit Tests:** Jest + Mocha for backend & frontend logic
* **Integration Tests:** API endpoint validation
* **E2E Tests:** Playwright for full user workflows
* **Load Testing:** JMeter to ensure scaling under traffic

---

## Build and Deploy

* **CI/CD:** GitHub Actions for auto-build
* **Deployment:** Docker containers deployed
* **Monitoring:** CloudWatch dashboards for system health

---

## Performance

Optimized for **low-latency data fetch** using **Redis caching**, **lazy loading of maps**, and **compression**. **CDN delivery** ensures fast global access.

---

## Customization

Users can **customize dashboards** with widgets, data filters (waste, pollution, flood alerts), and **export reports in PDF/Excel** for policy planning.

---

## Contributing

The project is **open for collaboration**. Developers can fork the repo, submit pull requests, or propose new features via **GitHub Issues**. Contribution guidelines are included for **standard coding practices**.

---

## Framing

The platform frames **sustainable cities as an integrated ecosystem**, connecting **data, people, and policy**. It’s not just a tool but a **global urban intelligence hub**.

---

## Educational Configuration

Includes **modules for schools**:

* **Interactive eco-games**
* **NASA Earth learning videos**
* **Quizzes** on climate and waste
* **Localized citizen tasks** to build awareness

---

## Acknowledgement

We acknowledge **NASA Earth Data (EONET API)** for climate data, and **open-source contributors** who help maintain the platform. Special thanks to **Team Cloud Drone** for leading the initiative against waste pollution in Bangladesh.

---

## Methodology

### Step 1: Data Preprocessing

1. **Collect multi-source datasets** including:

   * NASA Earth Observation (EO) data.
   * IoT smart bin data and drone imagery.
   * Flood forecasts and climate risk models.
   * City waste and population growth statistics.

2. **Clean, filter, and standardize** datasets to remove noise, ensure data quality, and harmonize different formats.

3. **Integrate diverse formats** (satellite, sensor, survey, GIS layers) into a **unified geospatial database** for advanced urban analysis.

---

### Step 2: Analyzing and Correlating Data

1. Apply **analytical and AI models** to detect waste hotspots, urban growth patterns, and environmental risks.
2. Correlate **urban growth trends** with **climate resilience indicators** (soil moisture, air quality, plastic waste accumulation, flood risk).
3. Use **GIS + AI-based spatial mapping** to visualize hotspots, vulnerable zones, and future risk projections.

---

### Step 3: Decision Support & Insights for Urban Planners

1. **Generate interactive dashboards** with real-time data and insights for policymakers.
2. Provide **scenario-based simulations**, e.g.:

   * Flood forecast + unmanaged waste impact on public health.
   * Rapid population growth + waste system strain.
3. Recommend **sustainable interventions**, including:

   * Optimized waste collection routes.
   * Zero-waste city planning models.
   * Plastic recycling and circular economy strategies.

---

### Step 4: Web-Based GIS Visualization

1. Deploy final maps and dashboards on a **web-based GIS platform** for accessibility.
2. Ensure **interactive and real-time visualizations** for waste management, climate resilience, and sustainability planning.

---

## KPI’s

### Technical KPI’s

* **Data Quality** – Accuracy of IoT/drone data; completeness of NASA EO datasets.
* **System Performance** – Real-time dashboard updates (< 3 sec response, > 99% uptime).
* **Analytical Accuracy** – Waste hotspot detection ≥ 90%; forecasting error < 10%.
* **User Engagement** – Active planners using dashboards; adoption rate of system recommendations.
* **Sustainability Impact** – Reduction in unmanaged waste, pollution levels, and health risks.

---

### Operational KPI’s

* **Waste Collection Efficiency** – % reduction in missed pickups, optimized routes.
* **System Availability** – Platform uptime & service reliability.
* **Data Processing Speed** – Time taken to clean and analyze datasets.
* **Planner Adoption** – Number of planners actively using the platform.
* **Sustainability Outcomes** – % decrease in urban waste pollution, improved recycling rates.

---

## Our Mission:
Our goal is remove waste pollution and create cleaner, healthier cities where people can thrive. To achieve this, we are developing a web application called Sustainable Planet — a decision-making platform designed for urban planners.

---