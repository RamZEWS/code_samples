package com.traveltogo.personnel.service;

import com.traveltogo.personnel.entity.Calendar;
import com.traveltogo.personnel.repository.CalendarRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

/**
 * Created by root on 13.09.2016.
 */
@Service
public class CalendarServiceImpl implements CalendarService {

    @Autowired
    private CalendarRepository calendarRepository;

    @Override
    public Iterable<Calendar> findAll() {
        return calendarRepository.findAll();
    }

    @Override
    public void deleteById(Long id) {
        calendarRepository.delete(id);
    }

    @Override
    public void save(Calendar calendar){
        calendarRepository.save(calendar);
    }
}
