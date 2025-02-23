import AuthPage from "@/components/pages/AuthPage.vue";
import CreateInterviewPage from "@/components/pages/CreateInterviewPage.vue";
import HomePage from "@/components/pages/HomePage.vue";
import InterviewPage from "@/components/pages/InterviewPage.vue";
import InterviewRatesPage from "@/components/pages/InterviewRatesPage.vue";
import ProfilePage from "@/components/pages/ProfilePage.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },

    {
        path: '/auth',
        name: 'auth',
        component: AuthPage,
    },

    {
        path: '/profile',
        name: 'profile',
        component: ProfilePage,
    },

    {
        path: '/interview/create',
        name: 'interview.create',
        component: CreateInterviewPage,
    },

    {
        path: '/interview/:token',
        name: 'interview.start',
        component: InterviewPage,
        props: true
    },

    {
        path: '/profile/rates',
        name: 'profile.rates',
        component: InterviewRatesPage,
    },
];

export default routes;