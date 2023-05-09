<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\CloudNaturalLanguage;

class ClassifyTextRequest extends \Google\Model
{
  protected $classificationModelOptionsType = ClassificationModelOptions::class;
  protected $classificationModelOptionsDataType = '';
  protected $documentType = Document::class;
  protected $documentDataType = '';

  /**
   * @param ClassificationModelOptions
   */
  public function setClassificationModelOptions(ClassificationModelOptions $classificationModelOptions)
  {
    $this->classificationModelOptions = $classificationModelOptions;
  }
  /**
   * @return ClassificationModelOptions
   */
  public function getClassificationModelOptions()
  {
    return $this->classificationModelOptions;
  }
  /**
   * @param Document
   */
  public function setDocument(Document $document)
  {
    $this->document = $document;
  }
  /**
   * @return Document
   */
  public function getDocument()
  {
    return $this->document;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ClassifyTextRequest::class, 'Google_Service_CloudNaturalLanguage_ClassifyTextRequest');
