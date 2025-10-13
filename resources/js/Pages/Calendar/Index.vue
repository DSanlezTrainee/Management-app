<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import ptLocale from "@fullcalendar/core/locales/pt";
import { usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const events = ref(page.props.events || []);

const handleDateClick = (info) => {
    router.visit(route("calendar.create"), { data: { date: info.dateStr } });
};

function formatEventTitle(event) {
    if (!event.time || !event.duration) return "";
    const [h, m] = event.time.split(":");
    const start = `${h.padStart(2, "0")}:${m.padStart(2, "0")}`;
    const duration = parseInt(event.duration, 10) || 0;
    const startDate = new Date(`2000-01-01T${start}:00`);
    const endDate = new Date(startDate.getTime() + duration * 60000);
    const end = `${endDate.getHours().toString().padStart(2, "0")}:${endDate.getMinutes().toString().padStart(2, "0")}`;
    return `${start} - ${end}`;
}

const handleEventClick = (info) => {
    if (info.event.id) {
        router.visit(route("calendar.show", info.event.id));
    }
};

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    events: events.value.map((ev) => ({
        ...ev,
        title: formatEventTitle(ev),
        color:
            ev.type_color ||
            ev.color ||
            (ev.type && ev.type.color) ||
            undefined,
    })),
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    locale: ptLocale,
    firstDay: 1,
    slotMinTime: "08:00:00",
    slotMaxTime: "20:00:00",
    allDaySlot: false,
    dateClick: handleDateClick,
    eventClick: handleEventClick,
});
</script>

<style scoped>
.fc .fc-daygrid-body {
    height: 100% !important;
    display: grid !important;
    grid-template-rows: repeat(6, 1fr) !important;
}
.fc .fc-daygrid-day {
    height: auto !important;
    min-width: 0 !important;
    padding: 0 !important;
    border: 1.5px solid #e0e7ef !important;
    background: #fff !important;
}
.fc .fc-daygrid-day-frame {
    min-height: 120px !important;
    height: auto !important;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding: 18px 10px 18px 10px !important;
    box-sizing: border-box;
    overflow: visible !important;
}
.fc .fc-daygrid-event-harness {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    overflow: visible !important;
}
.fc .fc-event-title {
    font-size: 1.1rem !important;
    line-height: 1.5 !important;
    padding: 4px 6px !important;
    white-space: normal !important;
    word-break: break-word !important;
    overflow-wrap: anywhere !important;
    min-height: 2.5em !important;
    display: block !important;
    max-width: 100% !important;
    overflow: visible !important;
}
.fc .fc-daygrid-event {
    white-space: normal !important;
    overflow: visible !important;
    max-width: 100% !important;
    word-break: break-word !important;
    display: block !important;
}
.fc .fc-daygrid-day-events {
    flex: 1 1 auto;
}
.fc .fc-event {
    min-height: 2.5em !important;
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    overflow: visible !important;
    white-space: normal !important;
}
.fc .fc-daygrid-event {
    white-space: normal !important;
    overflow: visible !important;
    max-width: 100% !important;
}
.fc .fc-daygrid-day-number {
    font-size: 1.25rem !important;
    line-height: 1.6 !important;
    padding: 4px 0 !important;
}
.fc .fc-daygrid-day-number {
    font-weight: 700 !important;
    letter-spacing: 0.5px;
}
.fc .fc-scrollgrid-section-header .fc-col-header-cell {
    font-size: 1.15rem !important;
    padding: 10px 0 !important;
}
.fc .fc-toolbar-title {
    font-size: 1.7rem !important;
}
</style>

<template>
    <AppLayout title="Calendar">
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Calendar</h1>
            </div>
        </template>
        <div
            class="bg-white rounded shadow p-8 min-h-[1000px] mt-12 flex justify-center items-center"
            style="
                max-width: 2200px;
                width: 100%;
                margin: 0 auto;
                min-width: 1200px;
            "
        >
            <FullCalendar
                :options="calendarOptions"
                height="900px"
                style="width: 100%; min-width: 1100px; min-height: 900px"
            />
        </div>
    </AppLayout>
</template>
