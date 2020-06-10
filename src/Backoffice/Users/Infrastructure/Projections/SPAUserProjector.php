<?php


namespace Cuadrik\Backoffice\Users\Infrastructure\Projections;


class SPAUserProjector
{
    public static function execute($user)
    {

        return [
            'token' => $user->token()->value(),
            'user' =>[
                'data' => [
                    'username' => $user->username()->value(),
                    'displayName' => $user->displayName()->value(),
                    'firstname' => $user->firstname()->value(),
                    'lastname' => $user->lastname()->value(),
                    'email' => $user->email()->value(),
                    'photoURL' => "assets/images/avatars/".$user->photoUrl()->value(),
                    "settings"=>[
                        "layout"=>[
                            "style"=>"layout2",
                            "config"=>[
                                "scroll"=>"content",
                                "navbar"=>[
                                    "display"=>true,
                                    "folded"=>true,
                                    "position"=>"left"
                                ],
                                "toolbar"=>[
                                    "display"=>true,
                                    "style"=>"fixed",
                                    "position"=>"below"
                                ],
                                "footer"=>[
                                    "display"=>false,
                                    "style"=>"fixed",
                                    "position"=>"below"
                                ],
                                "mode"=>"fullwidth"
                            ]
                        ],
                        "customScrollbars"=>true,
                        "theme"=>[
                            "main"=>"defaultDark",
                            "navbar"=>"defaultDark",
                            "toolbar"=>"defaultDark",
                            "footer"=>"defaultDark"
                        ]
                    ],
                    "shortcuts"=>[
                        "calendar",
                        "mail",
                        "contacts"
                    ]
                ],
                'from' => "main-db",
                'role' => "admin",
    //            'role' => $user->getRoles(),
                'uuid' => $user->uuid()->value(),
    //            ...
            ]
        ];



    }

}