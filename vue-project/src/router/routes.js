import AuthPage from "@/components/pages/AuthPage.vue";
import CreateInterviewPage from "@/components/pages/Interview/CreateInterviewPage.vue";
import HomePage from "@/components/pages/HomePage.vue";
import InterviewPage from "@/components/pages/Interview/InterviewPage.vue";
import InterviewRatesPage from "@/components/pages/profile/InterviewRatesPage.vue";
import ProfilePage from "@/components/pages/profile/ProfilePage.vue";
import ViewInterviewRatePage from "@/components/pages/profile/ViewInterviewRatePage.vue";
import InterviewsManagePage from "@/components/pages/profile/InterviewsManagePage.vue";
import InterviewResultsPage from "@/components/pages/profile/InterviewResultsPage.vue";
import ViewUserAnswers from "@/components/pages/profile/ViewUserAnswers.vue";
import InterviewEditPage from "@/components/pages/Interview/InterviewEditPage.vue";

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

    {
        path: '/profile/interview-manage',
        name: 'profile.interview.manage',
        component: InterviewsManagePage,
    },

    {
        path: '/profile/interview-manage/result/:token',
        name: 'profile.interview.manage.result',
        component: InterviewResultsPage,
        props: true
    },

    {
        path: '/profile/interview-manage/edit/:token',
        name: 'profile.interview.manage.edit',
        component: InterviewEditPage,
        props: true
    },

    {
        path: '/profile/rate/:id',
        name: 'profile.rate',
        component: ViewInterviewRatePage,
        props: true
    },

    {
        path: '/profile/view-user-results/:id',
        name: 'profile.interview.manage.answers',
        component: ViewUserAnswers,
        props: true
    },
];

export default routes;