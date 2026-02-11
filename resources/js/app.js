// App JS

window.searchableSelect = function searchableSelect(config) {
    return {
        isOpen: false,
        searchTerm: '',
        selectedName: config.selectedName || '',
        selectedDisplay: config.selectedDisplay || '',
        allOptions: config.allOptions || [],
        get filteredOptions() {
            if (!this.searchTerm) {
                return this.allOptions;
            }
            const term = this.searchTerm.toLowerCase();
            return this.allOptions.filter((opt) =>
                (opt.displayName || opt.name || '').toLowerCase().includes(term),
            );
        },
        init() {
            this.$watch('isOpen', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        if (this.$refs.searchInput) {
                            this.$refs.searchInput.focus();
                        }
                    });
                } else {
                    this.searchTerm = '';
                }
            });
        },
        selectOption(option) {
            this.selectedName = option.name;
            this.selectedDisplay = `${option.displayName} (${option.room})`;
            this.isOpen = false;
            this.searchTerm = '';

            if (this.$wire && typeof this.$wire.updateSelection === 'function') {
                this.$wire.updateSelection(config.index, 0, option.name);
            }
        },
    };
};

window.googleMapsAutocomplete = function googleMapsAutocomplete() {
    return {
        initAutocomplete() {
            const checkGoogle = setInterval(() => {
                if (window.google && window.google.maps && window.google.maps.places) {
                    clearInterval(checkGoogle);
                    this.setupAutocomplete(this.$refs.luogoCarico, 'luogoCarico');
                    this.setupAutocomplete(this.$refs.luogoScarico, 'luogoScarico');
                }
            }, 200);
        },
        setupAutocomplete(input, field) {
            if (!input) {
                return;
            }

            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();

                if (place && place.geometry && this.$wire) {
                    this.$wire.set(field, place.formatted_address);
                }
            });
        },
    };
};
