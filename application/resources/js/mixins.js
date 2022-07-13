import { COOKIE_TOKEN } from './constants';

export const getToken = {
    methods: {
        getToken() {
            return document.cookie
            .split('; ')
            .find(row => row.startsWith(`${COOKIE_TOKEN}=`))
            ?.split('=')[1];
        }
    }
}
