// Toggle mobile menu
document.addEventListener('DOMContentLoaded', function() {
    // Application filtering
    Alpine.data('applicationList', () => ({
        filters: {
            status: '',
            date: ''
        },

        get filteredApplications() {
            return this.applications.filter(app => {
                const matchesStatus = !this.filters.status ||
                    app.status === this.filters.status;
                const matchesDate = !this.filters.date ||
                    new Date(app.created_at).toISOString().split('T')[0] === this.filters.date;

                return matchesStatus && matchesDate;
            });
        }
    }));

    // Rich text editor initialization
    document.querySelectorAll('[x-data@ckeditor]').forEach(el => {
        ClassicEditor
            .create(el)
            .catch(error => {
                console.error(error);
            });
    });
});
