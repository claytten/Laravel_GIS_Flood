@extends('layouts.admin.app',[
    'menu'  => 'dashboard',
    'second_title' => 'dashboard'
])

@section('content_header')
<div >
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone ">
        <h4>Dashboard</h4>
    </div>
</div>
@endsection

@section('content_alert')
@if(Session::get('message'))
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone mdl-shadow--2dp alert {{ Session::get('status') ? 'background-color--'.Session::get('status') : ' ' }}">
        <button type="button" class="close-alert">×</button>
        <i class="material-icons">{{ Session::get('icon') }}</i>
        {{ Session::get('message') }}
    </div>
@endif
@endsection

@section('content_body')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

    <!-- Trending widget-->
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
        <div class="mdl-card mdl-shadow--2dp trending">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Trending</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <ul class="mdl-list">
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content list__item-text">UX</span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="material-icons trending__arrow-up" role="presentation">&#xE5C7</i>
                        </span>
                        <span class="mdl-list__item-secondary-content trending__percent">1 %</span>
                    </li>
                    <li class="mdl-list__item list__item--border-top">
                        <span class="mdl-list__item-primary-content list__item-text">PHP</span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="material-icons trending__arrow-down" role="presentation">&#xE5C5</i>
                        </span>
                        <span class="mdl-list__item-secondary-content trending__percent">2 %</span>
                    </li>
                    <li class="mdl-list__item list__item--border-top">
                        <span class="mdl-list__item-primary-content list__item-text ">Big Data</span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="material-icons trending__arrow-up" role="presentation">&#xE5C7</i>
                        </span>
                        <span class="mdl-list__item-secondary-content trending__percent">5 %</span>
                    </li>
                    <li class="mdl-list__item list__item--border-top">
                        <span class="mdl-list__item-primary-content list__item-text">Material Design</span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="material-icons trending__arrow-up" role="presentation">&#xE5C7</i>
                        </span>
                        <span class="mdl-list__item-secondary-content trending__percent">18 %</span>
                    </li>
                    <li class="mdl-list__item list__item--border-top">
                        <span class="mdl-list__item-primary-content">JavaScript</span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="material-icons trending__arrow-up" role="presentation">&#xE5C7</i>
                        </span>
                        <span class="mdl-list__item-secondary-content trending__percent">17 %</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ToDo_widget-->
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
        <div class="mdl-card mdl-shadow--2dp todo">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">To-do list</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <ul class="mdl-list">

                </ul>
            </div>
            <div class="mdl-card__actions">
                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">remove selected</button>
                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-shadow--8dp mdl-button--colored ">
                    <i class="material-icons mdl-js-ripple-effect">add</i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Table-->
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone ">
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp projects-table">
            <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">Project</th>
                <th class="mdl-data-table__cell--non-numeric">Responsible</th>
                <th class="mdl-data-table__cell--non-numeric">Client contact</th>
                <th class="mdl-data-table__cell--non-numeric">Deadline</th>
                <th class="mdl-data-table__cell--non-numeric">Progress</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="mdl-data-table__cell--non-numeric">Darkboard</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <span class="label label--mini color--light-blue">Alex</span>
                    <span class="label label--mini background-color--primary">Dina</span>
                    <span class="label label--mini color--orange">Misha</span>
                </td>
                <td class="mdl-data-table__cell--non-numeric">Luke@skywalker.com</td>
                <td class="mdl-data-table__cell--non-numeric">Jun 15</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <div id="task1" class="mdl-progress mdl-js-progress"></div>
                    <div class="mdl-tooltip" for="task1">
                        44%
                    </div>
                </td>
            </tr>
            <tr>
                <td class="mdl-data-table__cell--non-numeric">Big financial app</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <span class="label label--mini color--orange">Vlada</span>
                </td>
                <td class="mdl-data-table__cell--non-numeric">Boss@financial.com</td>
                <td class="mdl-data-table__cell--non-numeric">Mar 1</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <div id="task2" class="mdl-progress mdl-js-progress"></div>
                    <div class="mdl-tooltip" for="task2">
                        14%
                    </div>
                </td>
            </tr>
            <tr class="is-selected">
                <td class="mdl-data-table__cell--non-numeric">New Year office decoration</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <span class="label label--mini background-color--primary">Dina</span>
                    <span class="label label--mini color--orange">Vlada</span>
                </td>
                <td class="mdl-data-table__cell--non-numeric">info@creativeit.io</td>
                <td class="mdl-data-table__cell--non-numeric">Dec 25</td>
                <td class="mdl-data-table__cell--non-numeric task-done">
                    <i id="task3" class="material-icons">done</i>
                    <span>Complete</span>
                </td>
            </tr>
            <tr>
                <td class="mdl-data-table__cell--non-numeric">Don't worry, be happy!!!</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <span class="label label--mini background-color--secondary">Everybody</span>
                </td>
                <td class="mdl-data-table__cell--non-numeric">Contact@happyness.com</td>
                <td class="mdl-data-table__cell--non-numeric">Yesterday</td>
                <td class="mdl-data-table__cell--non-numeric">
                    <div id="task4" class="mdl-progress mdl-js-progress"></div>
                    <div class="mdl-tooltip" for="task4">
                        31%
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection