<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\EnumType;

require_once('../include/TypeRegister.php');

class TaxonNameType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "A TaxonName a string of characters used to name a taxon under as governed by the 
                International Code of Botanical Nomenclature (ICBN) https://www.iapt-taxon.org/nomen/main.php.
                TaxonNames may appear as the single correct name for a taxon or as one of the synonyms for that taxon.",
            'fields' => function(){
                return [
                    'id' => [
                        'type' => Type::string(),
                        'description' => "A locally identifier for this Name (actually the WFO ID for the name)",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getId();}
                    ],
                    'title' => [
                        'type' => Type::string(),
                        'description' => 'Needed by some GraphQL libraries this is a string rendering of he object probably only useful in development',
                        'resolve'=>function($record, $args, $context, $info) {return $record->getTitle();}
                    ],
                    'stableUri' => [
                        'type' => Type::string(),
                        'description' => "A URI to the human readable web page for this resource.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getStableUri();}
                    ],
                    'classificationId' => [
                        'type' => Type::string(),
                        'description' => "The ID of the classification this name belongs to e.g. 2022-12.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getClassificationId();}
                    ],
                    'fullNameStringHtml' => [
                        'type' => Type::string(),
                        'description' => "The full representation of the name with HTML tags",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getFullNameStringHtml();}
                    ],
                    'fullNameStringPlain' => [
                        'type' => Type::string(),
                        'description' => "The full representation of the name without HTML tags",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getFullNameStringPlain();}
                    ],
                    'fullNameStringNoAuthorsPlain' => [
                        'type' => Type::string(),
                        'description' => "The representation of the name without HTML tags or authors.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getFullNameStringNoAuthorsPlain();}
                    ],
                    'fullNameStringNoAuthorsHtml' => [
                        'type' => Type::string(),
                        'description' => "The representation of the name without authors but with HTML tags.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getFullNameStringNoAuthorsHtml();}
                    ],

                    'nameString' => [
                        'type' => Type::string(),
                        'description' => "One of the three words of the name. The main word for this name and is always present. For genus and above it is the 'mononomial'. For species it is the specific epithet. ",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getNameString();}
                    ],
                    'genusString' => [
                        'type' => Type::string(),
                        'description' => "For binomials and trinomials this is the genus part of the name.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getGenusString();}
                    ],
                    'speciesString' => [
                        'type' => Type::string(),
                        'description' => "For trinomials this is the species part of the name.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getSpeciesString();}
                    ],
                    'authorsString' => [
                        'type' => Type::string(),
                        'description' => "The authors string with no markup.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getAuthorsString();}
                    ],
                    'authorsStringHtml' => [
                        'type' => Type::string(),
                        'description' => "The authors string with HTML tags giving details of the author abbreviations if known.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getAuthorsStringHtml();}
                    ],
                    'nomenclaturalStatus' => [
                        'type' => Type::string(),
                        'description' => "The strict nomenclatural status of the Name (not the taxonomic status/role)",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getNomenclaturalStatus();}
                    ],
                    'role' => [
                        'type' => Type::string(),
                        'description' => "The role this name plays in the classification: 
                            accepted (placed as the accepted name of a taxon), 
                            synonym (placed as a synonym of a taxon), 
                            unplaced (a taxonomist hasn't yet to place the name in the taxonomy),
                            deprecated (it isn't possible to place this name in the taxonomy - do not use)",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getRole();}
                    ],
                    'rank' => [
                        'type' => new EnumType([
                            'name' => 'Rank',
                            'description' => 'Used for the relative position of the taxon with this name in the taxonomic hierarchy at time of publication.
                                For suprageneric names published on or after 1 January 1887, the rank is indicated by the termination of the name.
                                For names published on or after 1 January 1953, a clear indication of the rank is required for valid publication.',
                            'values' => ["code","kingdom","phylum","class","subclass","superorder","order","suborder","family","subfamily","supertribe","tribe","subtribe","genus","subgenus","section","subsection","series","subseries","species","subspecies","prole","variety","subvariety","form","subform","unranked"]
                        ]),
                        "description" => "The name of the level within the classification at which this name was published.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getRank();}
                    ],
                    'comment' => [
                        'type' => Type::string(),
                        'description' => "Notes and comments about this Name",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getComment();}
                    ],

                    'citationMicro' => [
                        'type' => Type::string(),
                        'description' => "The plublication string for the name in the form of a microcitation as used in floras and monographs.",
                        'resolve'=>function($record, $args, $context, $info) {return $record->getCitationMicro();}
                    ],

                    'identifiersOther' => [
                        'type' => Type::listOf(TypeRegister::identifierType()),
                        'description' => "Other identifiers used for this name",
                        'resolve' => function($record){return $record->getIdentifiersOther();}
                    ],
                    'wfoIdsDeduplicated' => [
                        'type' => Type::listOf(Type::string()),
                        'description' => "WFO IDs that have been deduplicated into this name.",
                        'resolve' => function($record){return $record->getWfoIdsDeduplicated();}
                    ],
                    'references' => [
                        'type' => Type::listOf(TypeRegister::referenceType()),
                        'description' => "References to other resources on the internet.",
                        'resolve' => function($record){return $record->getNomenclaturalReferences();}
                    ],
                    'currentPreferredUsage' => [
                        'type' => TypeRegister::taxonConceptType(),
                        'resolve' => function($record){
                            return $record->getCurrentUsage();
                        },
                        'description' => 'The TaxonConcept to which this TaxonName is assigned 
                        (either as the accepted name or a synonym) in the currently preferred (most recent) version of the WFO classification.'
                    ]

/*
    private ?TaxonRecord $currentUsage = null;
    private ?TaxonRecord $parent = null;
    private ?Array $children = null;
    private ?Array $synonyms = null;

                    'acceptedNameFor' => [
                        'type' => Type::listOf(TypeRegister::taxonConceptType()),
                        'resolve' => function($name){
                            return $name->getAcceptedNamesFor();
                        },
                        'description' => 'The TaxonConcept for which this is the accepted name. A value of null means this name is currently considered a synonym and the 
                        currentPreferredUsage will return the TaxonConcept in which this is considered a'

                    ],


                    'currentPreferredUsageIsSynonym' =>[
                        'type' => Type::boolean(),
                        'description' => "Whether this name is a synonym in the currently preferred (most recent) WFO classification.
                            This is a convenience flag. It is the equivalent of currentPreferredUsage>hasName>guid != guid. That is, the negation of does the preferred placement in
                            this classification have this name as its accepted name.
                        "
                    ]
*/
                    ];
            }
        ];
        parent::__construct($config);

    }



}