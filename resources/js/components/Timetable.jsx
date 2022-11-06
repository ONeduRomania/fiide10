import React, {useEffect, useMemo, useState} from 'react'
import {createRoot} from 'react-dom/client'
import {addWeeks, getISODay, isMonday, isWeekend, nextDay, set, startOfISOWeek} from 'date-fns';
import {Scheduler} from "@aldabil/react-scheduler";
import {ro} from 'date-fns/esm/locale'
import axios from 'axios';

const TimetableComponent = (props) => {
    const {timetable, updateurl, deleteurl, createurl, subjects} = props;
    const [lessons, setLessons] = useState([]);
    const subjectsObj = useMemo(() => JSON.parse(subjects).map(s => ({
        id: s.id,
        text: s.name,
        value: s.id
    })), [subjects]);
    useEffect(() => {
        const lessons = JSON.parse(timetable).map(lesson => {
            const dates = JSON.parse(lesson.data);

            let today = new Date();
            const startDate = new Date(dates.startTime);
            const endDate = new Date(dates.endTime);

            if (isWeekend(today)) {
                // Show next week if we are during the weekend.
                today = startOfISOWeek(addWeeks(today, 1));
            }

            const dayOfWeek = getISODay(startDate);

            // If we are on Monday, we should show today, otherwise the lessons will be pushed to next Monday.
            const currentWeekDay = isMonday(startDate) ? startOfISOWeek(today) : nextDay(today, dayOfWeek)
            return ({
                event_id: lesson.id,
                title: lesson.subjects.name,
                subject: lesson.subjects.id,
                color: "#00385b",
                start: set(
                    new Date(currentWeekDay),
                    {
                        hours: startDate.getHours(),
                        minutes: startDate.getMinutes()
                    }
                ),
                end: set(
                    new Date(currentWeekDay),
                    {
                        hours: endDate.getHours(),
                        minutes: endDate.getMinutes()
                    }
                ),
            })
        });
        setLessons(lessons);
    }, []);

    /**
     *
     * @param newEvent
     * @param {"create"|"edit"} action
     */
    const updateLesson = async (newEvent, action) => {
        const body = new URLSearchParams();
        body.set("subject", newEvent.subject);
        body.set("date_start", newEvent.start);
        body.set("date_end", newEvent.end);
        body.set("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        try {
            if (action === "create") {
                const newResp = await axios.post(createurl, body);
                const lesson = newResp.data;
                return {
                    ...newEvent,
                    event_id: lesson.id,
                    title: subjectsObj.filter(s => s.id === newEvent.subject)[0].text
                };
            } else {
                let url = updateurl.replace(":timetable_id", newEvent.event_id);
                await axios.patch(url, body);
                return newEvent;
            }
        } catch (e) {
            console.error(e);
            alert("A apărut o eroare la modificarea orarului. Te rugăm să încerci din nou, iar dacă tot nu funcționează contactează-ne pentru a te putea ajuta.")
        }
    }

    const deleteLesson = async (lessonId) => {
        let url = deleteurl.replace(":timetable_id", lessonId);
        await axios.delete(url);
        return lessonId;
    }

    const moveLesson = (_, updated) => {
        return updateLesson(updated, "edit");
    }

    // TODO: Enable edit only for admins
    return <Scheduler
        events={lessons}
        editable={true}
        draggable={true}
        deletable={true}
        onConfirm={updateLesson}
        onDelete={deleteLesson}
        onEventDrop={moveLesson}
        fields={[
            {
                // Required for library
                name: "title",
                type: "hidden"
            },
            {
                name: "subject",
                type: "select",
                options: subjectsObj,
                config: {
                    label: "Materie",
                    required: true,
                    errMsg: "Selectează o materie!"
                }
            },
            {
                name: "start",
                type: "date",
                config: {
                    label: "Oră început",
                    required: true,
                    errMsg: "Selectează când începe ora de curs!"
                }
            },
            {
                name: "end",
                type: "date",
                config: {
                    label: "Oră final",
                    required: true,
                    errMsg: "Selectează când se termină ora de curs!"
                }
            },
        ]}
        locale={ro}
        hourFormat="24"
        week={{
            weekDays: [1, 2, 3, 4, 5],
            startHour: 6,
            endHour: 20,
            weekStartOn: 0,
            step: 60
        }}
        day={{
            startHour: 6,
            endHour: 20,
            step: 60
        }
        }
        translations={{
            navigation: {
                month: "Lună",
                today: "Azi",
                day: "Zi",
                week: "Săptămână"
            },
            form: {
                addTitle: "Adaugă oră de curs",
                cancel: "Anulează",
                confirm: "Salvează",
                delete: "Șterge",
                editTitle: "Editează ora de curs"
            },
            event: {
                end: "Oră final",
                start: "Oră început",
                title: "Materie"
            },
            moreEvents: "în plus"
        }
        }
    />

}

if (document.getElementById('timetable-component')) {
    const element = document.getElementById('timetable-component')
    const props = Object.assign({}, element.dataset)
    const root = createRoot(element)

    root.render(<TimetableComponent {...props}/>)
}
