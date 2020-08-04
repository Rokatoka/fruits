import RegisterComponent from "./components/Register";
import LoginComponent from "./components/Login";
import BoxesList from "./components/BoxesList";
import FruitsApplication from "./components/FruitsApplication";

export const routes = [
    {
        name: 'register',
        path: '/register',
        component: RegisterComponent,
        meta: {
            forAuth: false,
            title: 'Registration',
            forAdmin: false
        }
    },
    {
        name: 'login',
        path: '/login',
        component: LoginComponent,
        meta: {
            forAuth: false,
            title: 'Login',
            forAdmin: false
        }
    },
    {
        name: 'boxesList',
        path: '/list',
        component: BoxesList,
        meta: {
            forAuth: true,
            title: 'List of Boxes',
            forAdmin: true
        }
    },
    {
        name: 'fruitApplication',
        path: '/application',
        component: FruitsApplication,
        meta: {
            forAuth: true,
            title: 'Place Fruits in BoxCollection',
            forAdmin: false
        }
    }
];
