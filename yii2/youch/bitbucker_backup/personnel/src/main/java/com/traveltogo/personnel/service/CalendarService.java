package com.traveltogo.personnel.service;

import com.traveltogo.personnel.entity.Calendar;

/**
 * Created by root on 13.09.2016.
 */
public interface CalendarService {

    public Iterable<Calendar> findAll();

    public void deleteById(Long id);

    public void save(Calendar calendar);
}
