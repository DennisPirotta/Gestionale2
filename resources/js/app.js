import './bootstrap';
import 'flowbite'
import Datepicker from 'flowbite-datepicker/Datepicker';
import DateRangePicker from 'flowbite-datepicker/DateRangePicker';
import '../sass/app.scss'

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Datepicker = Datepicker
window.DateRangePicker = DateRangePicker

Alpine.start();