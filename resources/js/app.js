import './bootstrap';
import 'flowbite'
import Datepicker from 'flowbite-datepicker/Datepicker';
import DateRangePicker from 'flowbite-datepicker/DateRangePicker';
import '../sass/app.scss'
import ApexCharts from 'apexcharts'
import Alpine from 'alpinejs';
import '@fullcalendar/core/vdom';
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for selectable
import listPlugin from '@fullcalendar/list';
import allLocales from '@fullcalendar/core/locales-all';

window.Alpine = Alpine;
window.Datepicker = Datepicker
window.DateRangePicker = DateRangePicker
window.ApexCharts = ApexCharts
window.Calendar = Calendar
window.dayGridPlugin = dayGridPlugin
window.timeGridPlugin = timeGridPlugin
window.listPlugin = listPlugin
window.interactionPlugin = interactionPlugin
window.allLocales = allLocales


Alpine.start();
