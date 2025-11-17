// Search functionality for admin lists (demons, pacts, etc.)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearBtn');
    
    if (!searchInput) {
        return; // No search on this page
    }

    // Get all searchable cards
    const cards = document.querySelectorAll('[data-searchable]');
    
    if (cards.length === 0) {
        return; // No cards to search
    }

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        cards.forEach(card => {
            const searchableText = card.dataset.searchable || '';
            const matches = searchableText.includes(searchTerm);
            card.style.display = matches ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            filterCards();
            searchInput.focus();
            
            // Always show toast when clear is clicked
            if (typeof window.showToast === 'function') {
                window.showToast('info', 'Búsqueda limpiada');
            }
        });
    }

    // CTRL+K shortcut
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });
});
