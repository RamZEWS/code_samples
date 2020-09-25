package com.traveltogo.personnel.entity;

import javax.persistence.*;

/**
 * Created by root on 13.09.2016.
 */
@Entity
@Table(name = "calendar")
public class Calendar {

    @Id
    @GeneratedValue
    private Integer id;

    @Column(name = "start_time")
    private String start;

    @Column(name = "end_time")
    private String end;

    @Column(name = "type")
    private String type;

    public Integer getId() {
        return id;
    }

    /*public void setId(Integer id) {
        this.id = id;
    }*/

    public String getStart() {
        return start;
    }

    public void setStart(String start) {
        this.start = start;
    }

    public String getEnd() {
        return end;
    }

    public void setEnd(String end) {
        this.end = end;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }
}
