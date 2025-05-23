document.addEventListener('DOMContentLoaded', function () {
    let selectedSkills = new Set();
    let skillSearchTimeout;

    // Helper function to safely get elements
    function getElement(selector) {
        return document.querySelector(selector);
    }

    // Helper function to safely handle class operations
    function safeClassOperation(element, operation, ...classes) {
        if (element && element.classList) {
            element.classList[operation](...classes);
        }
    }

    // Initialize elements
    const skillSearch = getElement('#skill-search');
    const skillSuggestions = getElement('#skill-suggestions');
    const selectedSkillsContainer = getElement('#selected-skills');
    const skillsInput = getElement('#skill-ids');

    // Function to handle skill search
    function handleSkillSearch(query) {
        if (!skillSuggestions) return;

        if (query.length < 2) {
            safeClassOperation(skillSuggestions, 'add', 'hidden');
            return;
        }

        const csrfToken = getElement('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(`/admin/skills/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                query: query,
                job_opening_id: 0
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error('Invalid data format received');
                }

                skillSuggestions.innerHTML = '';

                data.forEach(skill => {
                    if (!skill.id || !skill.name || selectedSkills.has(skill.id)) return;

                    const div = document.createElement('div');
                    div.className = 'p-2 hover:bg-gray-400 dark:hover:bg-gray-800 dark:hover:text-white dark:text-black cursor-pointer';
                    div.textContent = skill.name;
                    div.onclick = () => addSkill(skill);
                    skillSuggestions.appendChild(div);
                });

                safeClassOperation(skillSuggestions, 'remove', 'hidden');
            })
            .catch(error => {
                console.error('Error fetching skills:', error);
                if (toastr) {
                    toastr.error('Failed to fetch skills. Please try again.');
                }
            });
    }

    // Function to add a skill
    function addSkill(skill) {
        if (!skill?.id || !skill?.name || selectedSkills.has(skill.id)) return;
        if (!selectedSkillsContainer) return;

        try {
            selectedSkills.add(skill.id);

            const skillDiv = document.createElement('div');
            skillDiv.className = 'bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 px-3 py-1 rounded-full text-sm';

            const skillName = document.createTextNode(skill.name);
            skillDiv.appendChild(skillName);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'text-red-500 hover:text-red-700 font-bold text-lg ml-1';
            removeButton.textContent = '×';
            removeButton.dataset.skillId = skill.id;

            removeButton.addEventListener('click', function () {
                try {
                    const skillId = parseInt(this.dataset.skillId);
                    if (!isNaN(skillId)) {
                        selectedSkills.delete(skillId);
                        this.parentElement?.remove();
                        updateskills();
                    }
                } catch (error) {
                    console.error('Error removing skill:', error);
                }
            });

            skillDiv.appendChild(removeButton);
            selectedSkillsContainer.appendChild(skillDiv);

            if (skillSuggestions) {
                safeClassOperation(skillSuggestions, 'add', 'hidden');
            }
            if (skillSearch) {
                skillSearch.value = '';
            }

            updateskills();

        } catch (error) {
            console.error('Error adding skill:', error);
            if (toastr) {
                toastr.error('Failed to add skill. Please try again.');
            }
        }
    }

    // Function to update skill IDs in hidden input
    function updateskills() {
        try {
            if (skillsInput) {
                skillsInput.value = Array.from(selectedSkills).join(',');
            }
        } catch (error) {
            console.error('Error updating skill IDs:', error);
        }
    }

    // Initialize event listeners
    if (skillSearch) {
        skillSearch.addEventListener('input', function (e) {
            clearTimeout(skillSearchTimeout);
            const query = e.target?.value?.trim() || '';
            skillSearchTimeout = setTimeout(() => handleSkillSearch(query), 300);
        });
    }

    // Close suggestions when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target?.closest('#skill-search') && skillSuggestions) {
            safeClassOperation(skillSuggestions, 'add', 'hidden');
        }
    });

    // Initialize any existing skills (if editing a job posting)
    function initializeExistingSkills() {
        try {
            const existingSkills = skillsInput?.value?.split(',').filter(Boolean) || [];
            if (existingSkills.length > 0) {
                // You might need to fetch skill details from the server here
                // For now, we'll just initialize the Set
                existingSkills.forEach(id => {
                    const skillId = parseInt(id);
                    if (!isNaN(skillId)) {
                        selectedSkills.add(skillId);
                    }
                });
            }
        } catch (error) {
            console.error('Error initializing existing skills:', error);
        }
    }

    initializeExistingSkills();
});
