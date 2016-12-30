
export default {
    methods: {
        api(verb, path, data) {
            var verb = verb.toLowerCase();

            Vue.http.headers.common['Accept'] = 'application/x.pxcms.v1+json';
            Vue.http.headers.common['X-Auth-Token'] = window.Laravel.apiKey;
            return Vue.http[verb](path, data);
        }
    }
};

