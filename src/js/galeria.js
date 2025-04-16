(function() {
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.querySelector('#masonry-grid');
        new Masonry(grid, {
            itemSelector: '.galeria__item',
            columnWidth: '.galeria__item',
            percentPosition: true,
            gutter: 16
        });
    });
}());