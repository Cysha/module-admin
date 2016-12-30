export default {
    name: 'grid',
    template: `
        <div :class="position | grid-from-to">
            <div :class="modifyClass(modifiers, 'grid__tile')">
                 <slot></slot>
            </div>
        </div>
    `,

    props: ['modifiers', 'position'],

    methods: {
        modifyClass: function(modifiers, base){
            if (!modifiers) {
                return base;
            }

            modifiers = Array.isArray(modifiers) ? modifiers : modifiers.split(' ');
            modifiers = modifiers.map(modifier => `${base}--${modifier}`);

            return [base, ...modifiers];
        }
    }
};
