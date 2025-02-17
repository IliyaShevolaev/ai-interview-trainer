import AuthPage from "@/components/pages/AuthPage.vue";
import CreateInterviewPage from "@/components/pages/CreateInterviewPage.vue";
import HomePage from "@/components/pages/HomePage.vue";
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
];

export default routes;