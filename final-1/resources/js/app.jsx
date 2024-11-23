import './bootstrap';
import '../css/app.css';

// Alpine setup
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// React setup 
import React from 'react';
import ReactDOM from 'react-dom/client';
import BookCategory from './components/BookCategory';

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize React components
    const initializeReactComponents = () => {
        // Book Category Component
        const bookCategoryContainer = document.getElementById('react-book-category');
        if (bookCategoryContainer) {
            try {
                const root = ReactDOM.createRoot(bookCategoryContainer);
                root.render(
                    <React.StrictMode>
                        <BookCategory />
                    </React.StrictMode>
                );
            } catch (error) {
                console.error('Error initializing BookCategory component:', error);
            }
        }
    };

    initializeReactComponents();
});