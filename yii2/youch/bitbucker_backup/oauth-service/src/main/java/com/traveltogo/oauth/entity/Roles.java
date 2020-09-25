package com.traveltogo.oauth.entity;


import javax.persistence.*;
import java.util.Set;

/**
 * Created by allinse on 05.09.16.
 */
@Entity
@Table(name = "roles")
public class Roles {

    @Id
    @GeneratedValue
    private Integer id;

    @Column(name = "role")
    private String role;

    @OneToMany(cascade=CascadeType.ALL)
    @JoinTable(name="users_roles",
            joinColumns = {@JoinColumn(name="role_id", referencedColumnName="id")},
            inverseJoinColumns = {@JoinColumn(name="user_id", referencedColumnName="id")}
    )

    private Set<Users> usersRoles;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    public Set<Users> getUsersRoles() {
        return usersRoles;
    }

    public void setUsersRoles(Set<Users> usersRoles) {
        this.usersRoles = usersRoles;
    }
}
