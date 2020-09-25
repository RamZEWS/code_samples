package com.traveltogo.personnel.controller;

import com.traveltogo.personnel.entity.Calendar;
import com.traveltogo.personnel.service.CalendarService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

/**
 * Created by root on 13.09.2016.
 */
@RestController
@RequestMapping("/calendar")
public class CalendarController {

    @Autowired
    private CalendarService calendarService;

    @RequestMapping(value = "/events", method = RequestMethod.POST, produces = MediaType.APPLICATION_JSON_VALUE)
    public Iterable<Calendar> getFullEvents(){
        return calendarService.findAll();
    }

    @RequestMapping(value = "/events/save", method = RequestMethod.POST)
    public ResponseEntity<Calendar> saveEvents(@RequestBody Calendar calendar) {
        try {
           calendarService.save(calendar);
        } catch (Error e){
            return new ResponseEntity<Calendar>(calendar, HttpStatus.BAD_REQUEST);
        }

        return new ResponseEntity<Calendar>(calendar, HttpStatus.OK);
    }

    @RequestMapping(value = "/event/{id}", method = RequestMethod.POST, produces = MediaType.APPLICATION_JSON_VALUE)
    public void deleteEvents(@PathVariable Long id){
        calendarService.deleteById(id);
    }
}
