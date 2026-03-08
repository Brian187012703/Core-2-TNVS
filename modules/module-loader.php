<?php
header('Content-Type: application/javascript');
?>
// Module Loader System
// Dynamically loads modules and their resources

class ModuleLoader {
    constructor() {
        this.modules = ['fuel', 'crm', 'storeroom', 'driver', 'analytics', 'profile', 'settings'];
        this.loadedModules = new Set();
    }

    async loadModule(moduleName) {
        if (this.loadedModules.has(moduleName)) {
            return; // Already loaded
        }

        try {
            // Load CSS
            const cssLink = document.createElement('link');
            cssLink.rel = 'stylesheet';
            cssLink.href = `modules/${moduleName}/${moduleName}.css`;
            document.head.appendChild(cssLink);

            // Load JavaScript
            const script = document.createElement('script');
            script.src = `modules/${moduleName}/${moduleName}.js`;
            script.onload = () => {
                this.loadedModules.add(moduleName);
                console.log(`Module ${moduleName} loaded`);
            };
            document.body.appendChild(script);

        } catch (error) {
            console.error(`Failed to load module ${moduleName}:`, error);
        }
    }

    async loadModuleTemplate(moduleName) {
        try {
            const response = await fetch(`modules/${moduleName}/${moduleName}.html`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const html = await response.text();
            return html;
        } catch (error) {
            console.error(`Failed to load template for ${moduleName}:`, error);
            return '';
        }
    }

    async loadAndRender(moduleName) {
        // Load module resources
        await this.loadModule(moduleName);

        // Load and render template
        const template = await this.loadModuleTemplate(moduleName);
        const mainContent = document.getElementById('mainContent');

        if (mainContent && template) {
            mainContent.innerHTML = template;

            // Call module initialization if it exists
            if (window[`init${this.capitalize(moduleName)}Handlers`]) {
                window[`init${this.capitalize(moduleName)}Handlers`]();
            }
        }
    }

    capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
}

// Create global instance
const moduleLoader = new ModuleLoader();
