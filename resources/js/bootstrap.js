import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';





import Pikaday from 'pikaday';
window.Pikaday = Pikaday; 
import moment from 'moment';
window.moment = moment; //