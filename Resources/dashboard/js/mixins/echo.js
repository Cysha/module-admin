import { forIn } from 'lodash';

export default {
    created() {
        forIn(this.getEventHandlers(), (handler, eventName) => {
            let fullyQualifiedEventName = `.Cms.Modules.${eventName}`;

            Echo.private('acp-dashboard')
                .listen(fullyQualifiedEventName, (event) => {
                    //console.log(['Receiving Event', fullyQualifiedEventName, event]);
                    handler(event);
                });
        });
    },
};
