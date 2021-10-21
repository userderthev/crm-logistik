import MainComponent from './components/MainComponent.vue';

import ListProviderComponent from './components/ListProviderComponent.vue';
import AddProviderComponent from './components/AddProviderComponent.vue';
import EditProviderComponent from './components/EditProviderComponent.vue';

import EditLineComponent from './components/EditLineComponent.vue';
import TruckComponent from './components/TruckComponent.vue';
import TowingComponent from './components/TowingComponent.vue';
import OperatorComponent from './components/OperatorComponent.vue';

import ListClientsComponent from './components/ListClientsComponent.vue';
import AddClientsComponent from './components/AddClientsComponent.vue';
import EditClientComponent from './components/EditClientComponent.vue';

import BillingsComponent from './components/client/BillingComponent.vue';
import CollectComponent from './components/client/CollectComponent.vue';
import QuotationComponent from './components/client/QuotationComponent.vue';
import ContactComponent from './components/client/ContactComponent.vue';

import InternalAuditComponent from './components/InternalAuditComponent.vue';
import TrafficComponent from './components/TrafficComponent.vue';
import ProviderComponent from './components/ProviderComponent.vue';

import LogisticComponent from './components/LogisticComponent.vue';

import RemissionsComponent from './components/RemissionsComponent.vue';
import BillingComponent from './components/BillingComponent.vue';
import AnalyticsComponent from './components/AnalyticsComponent.vue';

import AllPosts from './components/AllPosts.vue';
import AddPost from './components/AddPost.vue';
import EditPost from './components/EditPost.vue';

export const routes = [
  {
    name: 'dashboard',
    path: '/home',
    component: MainComponent
  },
  {
    name: 'listProvider',
    path: '/providers',
    component: ListProviderComponent
  },
  {
    name: 'addProvider',
    path: '/addProvider',
    component: AddProviderComponent
  },
  {
    name: 'editProvider',
    path: '/editProvider/:el',
    component: EditProviderComponent
  },
  {
    name: 'truck',
    path: '/provider/truck',
    component: TruckComponent,
  },
  {
    name: 'towing',
    path: '/provider/towing',
    component: TowingComponent,
  },
  {
    name: 'operator',
    path: '/provider/operator',
    component: OperatorComponent,
  },
  {
    name: 'clients',
    path: '/clients',
    component: ListClientsComponent
  },
  {
    name: 'billings',
    path: '/clients/billing',
    component: BillingsComponent
  },
  {
    name: 'collect',
    path: '/clients/collect',
    component: CollectComponent
  },
  {
    name: 'quotation',
    path: '/clients/quotation',
    component: QuotationComponent
  },
  {
    name: 'contact',
    path: '/clients/contact',
    component: ContactComponent
  },
  {
    name: 'addClient',
    path: '/addClient',
    component: AddClientsComponent
  },
  {
    name: 'editClient',
    path: '/editClient',
    component: EditClientComponent
  },
  {
    name: 'internaludit',
    path: '/internalAudit',
    component: InternalAuditComponent,
  },
  {
    name: 'traffic',
    path: '/traffic',
    component: TrafficComponent,
  },
  {
    name: 'activeProviders',
    path: '/activeProviders',
    component: ProviderComponent,
  },
  {
    name: 'logistic',
    path: '/logistic',
    component: LogisticComponent,
  },
  {
    name: 'remissions',
    path: '/remissions',
    component: RemissionsComponent,
  },
  {
    name: 'billing',
    path: '/billing',
    component: BillingComponent,
  },
  {
    name: 'analytics',
    path: '/analytics',
    component: AnalyticsComponent,
  },
  {
    name: 'add',
    path: '/add',
    component: AddPost
  },
  {
    name: 'edit',
    path: '/edit/:id',
    component: EditPost
  }
];